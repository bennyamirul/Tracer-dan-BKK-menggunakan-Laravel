<html>

<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Export Data' }}</title>
</head>

<body>
    <table border="1">
        {{-- Header --}}
        <thead>
            <tr style="background-color: {{ $headerColor ?? '#4472C4' }}; color: white; font-weight: bold;">
                @foreach($headers as $header)
                <th>{{ $header }}</th>
                @endforeach
            </tr>
        </thead>

        {{-- Body --}}
        <tbody>
            @foreach($data as $index => $row)
            <tr @if($index % 2==0) style="background-color: #f9f9f9;" @endif>
                @foreach($row as $cell)
                <td>{{ $cell }}</td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>