<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Support\Enums\IconPosition;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ManageLogs extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'System Logs';

    protected static ?string $title = 'Application Logs';

    protected static ?int $navigationSort = 100;

    protected string $view = 'filament.pages.manage-logs';

    public $logs = [];

    public $logFiles = [];

    public $selectedFile = '';

    public $searchQuery = '';

    public $selectedLevels = [];

    public function mount(): void
    {
        $this->selectedLevels = [];
        $this->loadLogFiles();
        if (! empty($this->logFiles)) {
            $this->selectedFile = $this->logFiles[0];
            $this->loadLogs();
        }
    }

    public function loadLogFiles(): void
    {
        $logPath = storage_path('logs');
        if (File::exists($logPath)) {
            $this->logFiles = collect(File::files($logPath))
                ->filter(fn ($file) => Str::endsWith($file->getFilename(), '.log'))
                ->map(fn ($file) => $file->getFilename())
                ->sortByDesc(fn ($file) => File::lastModified($logPath.'/'.$file))
                ->values()
                ->toArray();
        }
    }

    public function loadLogs(): void
    {
        if (! $this->selectedFile) {
            $this->logs = [];

            return;
        }

        $logPath = storage_path('logs/'.$this->selectedFile);

        if (! File::exists($logPath)) {
            $this->logs = [];

            return;
        }

        $content = File::get($logPath);
        $lines = explode("\n", $content);

        $logs = [];
        $currentLog = null;

        foreach ($lines as $line) {
            if (preg_match('/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\]\s+[\w\.]+(\w+):(.+)$/', $line, $matches)) {
                if ($currentLog) {
                    $logs[] = $currentLog;
                }
                $currentLog = [
                    'timestamp' => $matches[1],
                    'level' => strtolower($matches[2]),
                    'message' => trim($matches[3]),
                    'stack' => '',
                ];
            } elseif ($currentLog && ! empty(trim($line))) {
                $currentLog['stack'] .= "\n".$line;
            }
        }

        if ($currentLog) {
            $logs[] = $currentLog;
        }

        $this->logs = array_reverse($logs);
    }

    public function updatedSelectedFile(): void
    {
        $this->loadLogs();
    }

    public function getFilteredLogsProperty(): array
    {
        $logs = $this->logs;

        if (! empty($this->searchQuery)) {
            $search = strtolower($this->searchQuery);
            $logs = array_filter($logs, function ($log) use ($search) {
                return str_contains(strtolower($log['message']), $search)
                    || str_contains(strtolower($log['stack']), $search);
            });
        }

        if (! empty($this->selectedLevels)) {
            $logs = array_filter($logs, function ($log) {
                return in_array($log['level'], $this->selectedLevels);
            });
        }

        return array_values($logs);
    }

    public function getLogStatsProperty(): array
    {
        $stats = [
            'total' => count($this->logs),
            'error' => 0,
            'warning' => 0,
            'info' => 0,
            'debug' => 0,
        ];

        foreach ($this->logs as $log) {
            $level = $log['level'];
            if (in_array($level, ['error', 'critical', 'emergency', 'alert'])) {
                $stats['error']++;
            } elseif ($level === 'warning') {
                $stats['warning']++;
            } elseif (in_array($level, ['info', 'notice'])) {
                $stats['info']++;
            } else {
                $stats['debug']++;
            }
        }

        return $stats;
    }

    public function getLogFileSize(string $filename): string
    {
        $logPath = storage_path('logs/'.$filename);

        if (! File::exists($logPath)) {
            return '0 B';
        }

        $size = File::size($logPath);

        if ($size < 1024) {
            return $size.' B';
        } elseif ($size < 1024 * 1024) {
            return round($size / 1024, 1).' KB';
        } else {
            return round($size / (1024 * 1024), 1).' MB';
        }
    }

    public function getLogFileModified(string $filename): string
    {
        $logPath = storage_path('logs/'.$filename);

        if (! File::exists($logPath)) {
            return '';
        }

        return date('M j, Y g:i A', File::lastModified($logPath));
    }

    public function clearLogs(): void
    {
        $logPath = storage_path('logs/'.$this->selectedFile);

        if (File::exists($logPath)) {
            File::put($logPath, '');
            $this->loadLogs();
        }
    }

    public function downloadLog()
    {
        $logPath = storage_path('logs/'.$this->selectedFile);

        return response()->download($logPath);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('refresh')
                ->label('Refresh')
                ->icon('heroicon-o-arrow-path')
                ->iconPosition(IconPosition::Before)
                ->action(fn () => $this->loadLogs()),
            Action::make('download')
                ->label('Download')
                ->icon('heroicon-o-arrow-down-tray')
                ->iconPosition(IconPosition::Before)
                ->action(fn () => $this->downloadLog()),
            Action::make('clear')
                ->label('Clear Logs')
                ->icon('heroicon-o-trash')
                ->iconPosition(IconPosition::Before)
                ->color('danger')
                ->requiresConfirmation()
                ->action(fn () => $this->clearLogs()),
        ];
    }
}
