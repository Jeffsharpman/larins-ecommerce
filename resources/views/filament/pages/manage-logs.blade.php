<x-filament-panels::page>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">System Logs</h3>
                <p class="text-sm text-gray-500">{{ $this->logStats['total'] }} entries · {{ $selectedFile }}</p>
            </div>
            <div class="flex items-center gap-3">
                @if($this->logStats['error'] > 0)
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-danger-500/10 text-danger-600 dark:text-danger-400 text-xs font-medium">
                        <span class="w-1.5 h-1.5 rounded-full bg-danger-500"></span>
                        {{ $this->logStats['error'] }} errors
                    </span>
                @endif
                @if($this->logStats['warning'] > 0)
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-warning-500/10 text-warning-600 dark:text-warning-400 text-xs font-medium">
                        <span class="w-1.5 h-1.5 rounded-full bg-warning-500"></span>
                        {{ $this->logStats['warning'] }} warnings
                    </span>
                @endif
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-3 p-4 bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700">
            <select
                wire:model.live="selectedFile"
                class="text-sm border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800 focus:ring-primary-500 focus:border-primary-500"
            >
                @foreach($logFiles as $file)
                    <option value="{{ $file }}">{{ $file }} ({{ $this->getLogFileSize($file) }})</option>
                @endforeach
            </select>

            <div class="flex-1 min-w-[200px]">
                <input
                    wire:model.live.debounce.300ms="searchQuery"
                    type="text"
                    placeholder="Search logs..."
                    class="w-full text-sm border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800 focus:ring-primary-500 focus:border-primary-500"
                />
            </div>

            <div class="flex items-center gap-2">
                @foreach(['error', 'warning', 'info'] as $level)
                    @php $isActive = is_array($selectedLevels) && in_array($level, $selectedLevels); @endphp
                    <button
                        type="button"
                        wire:click="
                            @if($isActive)
                                selectedLevels = selectedLevels.filter(l => l !== '{{ $level }}')
                            @else
                                selectedLevels.push('{{ $level }}')
                            @endif
                        "
                        class="px-3 py-1.5 text-xs font-medium rounded-lg border transition-all {{ $isActive ? ($level === 'error' ? 'bg-danger-500 border-danger-500 text-white' : ($level === 'warning' ? 'bg-warning-500 border-warning-500 text-white' : 'bg-info-500 border-info-500 text-white')) : 'border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-800 hover:border-gray-300 dark:hover:border-gray-600' }}"
                    >
                        {{ ucfirst($level) }}
                    </button>
                @endforeach
            </div>
        </div>

        <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 overflow-hidden">
            <div class="flex items-center justify-between px-4 py-3 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <span class="text-sm text-gray-600 dark:text-gray-400">{{ count($this->filteredLogs) }} of {{ count($this->logs) }} entries</span>
                <span class="text-xs text-gray-400">{{ $this->getLogFileModified($selectedFile) }}</span>
            </div>

            <div class="max-h-[450px] overflow-y-auto">
                @forelse($this->filteredLogs as $log)
                    <div class="flex items-start gap-4 px-4 py-3 border-b border-gray-100 dark:border-gray-800 last:border-0 hover:bg-gray-50/50 dark:hover:bg-gray-800/30 transition-colors">
                        <span class="text-xs font-semibold uppercase w-16 shrink-0 pt-0.5 {{ in_array($log['level'], ['error', 'critical', 'emergency', 'alert']) ? 'text-danger-500' : ($log['level'] === 'warning' ? 'text-warning-500' : 'text-gray-500') }}">
                            {{ $log['level'] }}
                        </span>
                        <span class="text-xs text-gray-400 w-20 shrink-0 pt-0.5">{{ substr($log['timestamp'], 11, 5) }}</span>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-800 dark:text-gray-200 leading-relaxed">{{ $log['message'] }}</p>
                            @if($log['stack'])
                                <details class="mt-2">
                                    <summary class="text-xs text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 cursor-pointer">View stack trace</summary>
                                    <pre class="mt-2 p-3 bg-gray-100 dark:bg-gray-800 rounded-lg text-xs text-gray-500 dark:text-gray-400 overflow-x-auto max-h-32 leading-relaxed">{{ trim($log['stack']) }}</pre>
                                </details>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center">
                        <p class="text-sm text-gray-400">No log entries found</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-filament-panels::page>
