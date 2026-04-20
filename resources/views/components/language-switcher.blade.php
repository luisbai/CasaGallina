@php
    $route = request()->route();

    // If no route, don't render anything
    if (!$route) {
        return;
    }

    $routeName = $route->getName();

    // If no route name, don't render anything
    if (!$routeName) {
        return;
    }

    $parameters = $route->parameters();

    // Determine if we're on an English route
    $isEnglishRoute = str_starts_with($routeName, 'english.');

    // Get the base route name (without english. prefix)
    $baseRouteName = $isEnglishRoute ? str_replace('english.', '', $routeName) : $routeName;

    // Generate Spanish URL
    $spanishURL = route($baseRouteName, $parameters);

    // Generate English URL if it exists
    $englishRouteName = 'english.' . $baseRouteName;
    $englishURL = Route::has($englishRouteName) ? route($englishRouteName, $parameters) : null;
@endphp

<div class="language-selector d-none d-sm-block">
    <a href="{{ $spanishURL }}">Español</a>
    <div class="divider"></div>
    @if($englishURL)
        <a href="{{ $englishURL }}">English</a>
    @else
        <span class="text-muted">English</span>
    @endif
</div>