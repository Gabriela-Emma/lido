<script type="application/ld+json">
    {
    "@context": "https://schema.org",
    "@type": "Article",
    "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "{{$post?->link}}"
    },

    "genre": "Blockchain Technology",
    "wordcount": "{{str_word_count($post->content)}}",
    "headline": "{{$post?->title}}",
    "keywords": "{{ collect(($post?->categories)->merge($post?->tags)) }}"
    "image": "{{$post?->hero_url}}",  
    "author": {
        "@type": "Person",
        "name": "{{$post?->user}}",
        "url": "https://www.lidonation.com/en/team"
    },  
    "publisher": {
        "@type": "Organization",
        "name": "Lido Nation",
        "logo": {
        "@type": "ImageObject",
        "url": "https://www.lidonation.com/img/llogo-transparent.png"
        }
    },
    "datePublished": "{{$post?->published_at}}"
    }
</script>