@extends("layouts.layout")

@section("content")
    <section id="ankündigungen">
        <h1>Willkommen bei der E-Mensa</h1>
        <p>Hier steht ein Text über die E-Mensa...</p>
    </section>

    <div class="box">
        <section id="speisen">
            <h2>Unsere Speisen</h2>
            <table>
                <tr>
                    <th>Gericht</th>
                    <th>Bild</th>
                    <th>Preis intern</th>
                    <th>Preis extern</th>
                </tr>
                @foreach($gerichte as $gericht)
                    <tr>
                        <td>{{ $gericht['name'] }}</td>
                        <td>
                            <img src="/img/gerichte/{{ $gericht['bildname'] ?? '00_image_missing' }}.jpg"
                                 alt="{{ $gericht['name'] }}"
                                 width="100" height="100">
                        </td>
                        <td>{{ $gericht['preisintern'].'€' }}</td>
                        <td>{{ $gericht['preisextern'] }}</td>
                    </tr>
                @endforeach
            </table>
        </section>
    </div>
@endsection

@section("cssextra")
@endsection

@section("jsextra")
    <script src="/js/highlight.min.js"></script>
    <script>hljs.highlightAll();</script>
@endsection
