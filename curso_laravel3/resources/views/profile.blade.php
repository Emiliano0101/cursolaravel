<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $user->name }}</title> 
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-12 my-3 pt-3 shadow">
                    <img src="{{ $user->image->url }}" class="float-start rounded-circle me-2" alt="{{ $user->name }}">
                    <h1>{{ $user->name }}</h1>
                    <h3>{{ $user->email }}</h3>
                    <p>
                        <strong>Instagram:</strong> <a href="https://instagram.com/{{ $user->profile->instagram }}" target="_blank">{{ $user->profile->instagram }}</a><br>
                        <strong>GitHub:</strong> <a href="https://github.com/{{ $user->profile->github }}" target="_blank">{{ $user->profile->github }}</a><br>
                        <strong>Web:</strong> <a href="{{ $user->profile->web }}" target="_blank">{{ $user->profile->web }}</a>
                    </p>
                    
                    <p>
                        <strong>País:</strong> {{ $user->profile->location->country }}<br>
                        <strong>Nivel:</strong> 
                        @if ($user->level) 
                            <a href="">{{ $user->level->name }}</a>
                        @else
                            ___
                        @endif
                    </p>
                    
                    <hr>
                    <p>
                        <strong>Grupos:</strong>
                        @forelse ($user->groups as $group)
                            <span class="badge bg-primary">{{ $group->name }}</span>
                        @empty
                            <em>No pertenece a ningún grupo</em>
                        @endforelse
                    </p>
                    
                    <hr>

                    <h3>Posts</h3>

                    <div class="row">
                        @foreach ($posts as $post)
                        <div class="col-6 mb-3">
                            <div class="card">
                                <div class="row">
                                    <div class="col-md-4">
                                        <img src="{{ $post->image->url }}" class="card-img" alt="{{ $post->name }}">
                                    </div>
                                    <div class="col-md-8">
                                        <h5 class="card-title">{{ $post->name }}</h5>
                                        <h6 class="card-subtitle text-muted">
                                            {{ $post->category->name }} | 
                                            {{ $post->comments_count }} | 
                                            {{ Str::plural('comentario', $post->comments_count) }}
                                        </h6>
                                        <p class="card-text small">
                                            @foreach ($post->tags as $tag) <!-- Agregué el símbolo $ en el foreach -->
                                            <span class="badge bg-light">
                                                #{{ $tag->name }}
                                            </span>
                                            @endforeach
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <h3>Videos</h3>

                    <div class="row">
                        @foreach ($videos as $video)
                        <div class="col-6 mb-3">
                            <div class="card">
                                <div class="row">
                                    <div class="col-md-4">
                                        <img src="{{ $post->image->url }}" class="card-img" alt="{{ $video->name }}">
                                    </div>
                                    <div class="col-md-8">
                                        <h5 class="card-title">{{ $video->name }}</h5>
                                        <h6 class="card-subtitle text-muted">
                                            {{ $video->category->name }} | 
                                            {{ $video->comments_count }} | 
                                            {{ Str::plural('comentario', $post->comments_count) }}
                                        </h6>
                                        <p class="card-text small">
                                            @foreach ($video->tags as $tag) <!-- Agregué el símbolo $ en el foreach -->
                                            <span class="badge bg-light">
                                                #{{ $tag->name }}
                                            </span>
                                            @endforeach
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
