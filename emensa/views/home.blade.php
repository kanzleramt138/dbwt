@extends("layouts.layout")

@section("content")
    <body>
        <section id="ankündigungen">
            <h1>Willkommen bei der E-Mensa</h1>
            <p>Hier steht ein Text über die E-Mensa...</p>
        </section>


        <div class="box">
            <section id="speisen">
                <h2>Unsere Speisen</h2>
                <table>
                    <tr>
                        <td>Gericht</td>
                        <td>Preis intern</td>
                        <td>Preis extern</td>
                    </tr>
                    @foreach($gerichte as $gericht)
                        <tr>
                            <td>{{ $gericht['name'] }}</td>
                            <td>{{ $gericht['preisintern'] }}</td>
                            <td>{{ $gericht['preisextern'] }}</td>
                        </tr>
                    @endforeach
                </table>
@endsection

@section("cssextra")
@endsection

@section("jsextra")
    <script src="/js/highlight.min.js"></script><script>hljs.highlightAll();</script>
@endsection