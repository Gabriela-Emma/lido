<x-comments::signed-comments-layout>

    Do you want to approve the comment?

    <form class="form" method="POST">
        @csrf
        <button id="confirmationButton" class="button" type="submit">Approve</button>
    </form>

</x-comments::signed-comments-layout>

<script>
    document.getElementById("confirmationButton").click();
</script>

