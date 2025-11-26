<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Export Data' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            margin: 20px;
        }

        .document-header {
            text-align: center;
            margin-bottom: 20px;

            border-bottom: 2px solid {
                    {
                    $headerColor ?? '#4472C4'
                }
            }

            ;
            padding-bottom: 10px;
        }

        .document-header h2 {
            margin: 5px 0;
            font-size: 16px;

            color: {
                    {
                    $headerColor ?? '#4472C4'
                }
            }

            ;
        }

        .info-line {
            margin: 3px 0;
            font-size: 11px;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th {
            background-color: {
                    {
                    $headerColor ?? '#4472C4'
                }
            }

            ;
            color: white;
            padding: 8px 5px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #ddd;
            font-size: 9px;
        }

        table td {
            padding: 6px 5px;
            border: 1px solid #ddd;
            font-size: 8px;
        }

        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 9px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    {{-- Document Header --}}
    @if(isset($documentTitle))
    <div class="document-header">
        <h2>{{ $documentTitle }}</h2>
        @if(isset($subtitle))
        <p class="info-line">{{ $subtitle }}</p>
        @endif
        <p class="info-line">
            <strong>Tanggal Export:</strong> {{ $exportDate ?? date('d F Y, H:i:s') }}
            @if(isset($total))
            | <strong>Total Data:</strong> {{ $total }}
            @endif
        </p>
    </div>
    @endif

    {{-- Table --}}
    <table>
        <thead>
            <tr>
                @foreach($headers as $header)
                <th>{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $row)
            <tr>
                @foreach($row as $cell)
                <td>{{ $cell }}</td>
                @endforeach
            </tr>
            @empty
            <tr>
                <td colspan="{{ count($headers) }}" style="text-align: center; padding: 20px; color: #999;">
                    Tidak ada data
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Footer --}}
    @if(isset($printedBy) || isset($footer))
    <div class="footer">
        @if(isset($printedBy))
        <p>Dicetak oleh: {{ $printedBy }}</p>
        @endif
        @if(isset($footer))
        <p>{{ $footer }}</p>
        @endif
    </div>
    @endif
</body>

</html>