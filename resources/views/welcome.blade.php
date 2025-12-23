<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Explore o Virtual Zoo com visualizações interativas de animais e taxonomias.">

    <title>Virtual Zoo</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-950 text-slate-50 antialiased">
    <div id="virtual-zoo-app" class="min-h-screen flex flex-col bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950">
        <noscript>
            <section class="p-6 max-w-3xl mx-auto text-center">
                <h1 class="text-3xl font-semibold">Virtual Zoo</h1>
                <p class="mt-4 text-slate-300">Ative o JavaScript do seu navegador para vivenciar a experiência completa do zoológico virtual.</p>
            </section>
        </noscript>
    </div>

    <script>
        window.__VIRTUAL_ZOO__ = {
            pageContext: @json($pageContext ?? []),
            taxonomy: @json($taxonomyTree ?? []),
            featuredAnimals: @json($featuredAnimals ?? []),
            assetBaseUrl: @json(rtrim(asset(''), '/') . '/'),
        };
    </script>
</body>

</html>
