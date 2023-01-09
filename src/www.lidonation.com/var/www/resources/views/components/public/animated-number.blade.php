@props(['number', 'time' => 800])
<div x-data="{ current: 0, target: {{$number}}, time: {{$time}} }"
     x-init="() => {
        start = current;
        const interval = Math.max(time / (target - start), 5);
        const step = (target - start) /  (time / interval);
        const handle = setInterval(() => {
            if(current < target)
                current += step
            else {
                clearInterval(handle);
                current = target
            }
            }, interval)
    }">
    <div x-text="Math.round(current) || '-'">-</div>
</div>
