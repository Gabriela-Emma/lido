<?php $collection = $collection ?? 'posts'; ?>
<section class="relative py-10">
    <div class="container">
        {{ ${$collection}->links() }}
    </div>
</section>
