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
@endsection

@section("cssextra")
@endsection

@section("jsextra")
    <script src="/js/highlight.min.js"></script><script>hljs.highlightAll();</script>
@endsection