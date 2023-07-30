<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Balanced Teams</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
		<script src="https://cdn.tailwindcss.com"></script>

    <body class="antialiased bg-slate-200">
		<div class="bg-white w-auto h-full rounded m-8">
			<div class="w-auto h-4 bg-white"></div>
			<div class="flex justify-center text-4xl m-8">
				Balanced Teams
			</div>
			<div class="grid gap-4 grid-cols-4">
				@foreach ($teams as $team)
				<div class="h-auto bg-slate-100 m-8 rounded-lg">
					<div class="flex justify-center m-2 pb-2 border-2 border-slate-100 border-b-indigo-500">
						Team {{ $team["name"] }}
					</div>
					@foreach ($team["players"] as $player)
					<div class="ml-2">{{ $loop->index + 1 . ". " . $player->first_name . " " . $player->last_name . " - " . $player->ranking . " (". ($player->can_play_goalie ? "Goalie" : "Player") .")"}}</div>
					@endforeach
					<div class="flex justify-center m-2 border-b-indigo-500">
						Total Player Ranking: {{ $team["players"]->sum('ranking') }}
					</div>
				</div>
				@endforeach
			</div>
			<div class="w-auto h-16 bg-white"></div>
		</div>
    </body>
</html>