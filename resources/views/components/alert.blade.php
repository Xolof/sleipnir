@props([
  'type' => null,
  'message' => null,
])

@php($class = match ($type) {
  'success' => 'text-slate-800 bg-green-400',
  'caution' => 'text-slate-800 bg-yellow-400',
  'warning' => 'text-slate-800 bg-red-400',
  default => 'text-slate-800 bg-indigo-400',
})

<div {{ $attributes->merge(['class' => "px-3 py-2 mb-4 {$class}"]) }}>
  {!! $message ?? $slot !!}
</div>
