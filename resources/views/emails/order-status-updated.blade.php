<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Status Updated</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f9fafb;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .status-box {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 50px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .status-new { background: #3b82f6; color: white; }
        .status-processing { background: #f59e0b; color: white; }
        .status-shipped { background: #10b981; color: white; }
        .status-delivered { background: #059669; color: white; }
        .status-cancelled { background: #ef4444; color: white; }
        .details {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .details table {
            width: 100%;
            border-collapse: collapse;
        }
        .details td {
            padding: 10px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .details td:first-child {
            color: #6b7280;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #6b7280;
            font-size: 12px;
        }
        .highlight {
            color: #667eea;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 style="margin: 0;">Order Status Updated</h1>
        <p style="margin: 10px 0 0 0; opacity: 0.9;">Your order status has been changed</p>
    </div>
    
    <div class="content">
        <p>Hello {{ $order->user->name }},</p>
        
        <p>We wanted to inform you that the status of your order <span class="highlight">#{{ $order->order_number }}</span> has been updated.</p>
        
        <div style="text-align: center; margin: 30px 0;">
            <p style="margin-bottom: 10px; color: #6b7280; font-size: 14px;">Previous Status</p>
            <span class="status-box status-{{ $previousStatus }}">{{ ucfirst($previousStatus) }}</span>
            
            <p style="margin: 20px 0 10px 0;">→</p>
            
            <p style="margin-bottom: 10px; color: #6b7280; font-size: 14px;">New Status</p>
            <span class="status-box status-{{ $newStatus }}">{{ ucfirst($newStatus) }}</span>
        </div>
        
        <div class="details">
            <table>
                <tr>
                    <td>Order Number</td>
                    <td><strong>#{{ $order->order_number }}</strong></td>
                </tr>
                <tr>
                    <td>Order Date</td>
                    <td>{{ $order->created_at->format('M j, Y g:i A') }}</td>
                </tr>
                <tr>
                    <td>Total Amount</td>
                    <td><strong>₦{{ number_format($order->grand_total, 2) }}</strong></td>
                </tr>
                <tr>
                    <td>Payment Status</td>
                    <td>{{ ucfirst($order->payment_status) }}</td>
                </tr>
                <tr>
                    <td>Shipping Method</td>
                    <td>{{ $order->shipping_method }}</td>
                </tr>
            </table>
        </div>
        
        @if($newStatus === 'processing')
            <p>Your order is now being processed. We'll notify you again when it's shipped!</p>
        @elseif($newStatus === 'shipped')
            <p>Great news! Your order has been shipped and is on its way to you.</p>
        @elseif($newStatus === 'delivered')
            <p>Your order has been delivered. We hope you enjoy your purchase!</p>
        @elseif($newStatus === 'cancelled')
            <p>Your order has been cancelled. If you have any questions, please contact us.</p>
        @endif
        
        <p>If you have any questions about your order, please don't hesitate to contact our support team.</p>
        
        <p style="margin-top: 30px;">Best regards,<br><strong>The Store Team</strong></p>
    </div>
    
    <div class="footer">
        <p>This is an automated message. Please do not reply directly to this email.</p>
    </div>
</body>
</html>
