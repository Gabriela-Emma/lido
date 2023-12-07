<h1>Translations</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Source ID</th>
                <th>Source Type</th>
                <th>Translation</th>
            </tr>
        </thead>
        <tbody>
            @foreach($translations as $translation)
                <tr>
                    <td>{{ $translation->id }}</td>
                    <td>{{ $translation->source_id }}</td>
                    <td>{{ $translation->source_type }}</td>
                    <td>{{ $translation->translation }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $translations->links() }}
</div>