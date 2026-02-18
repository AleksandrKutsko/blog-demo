{extends file='layouts/main.tpl'}


{block name="content"}

    {foreach $categories as $category}
        <section>
            <div class="container">
                <div class="blog-block">
                    <div class="blog-block__top">
                        <h2>{$category->title}</h2>
                        <a href="{route name='category-show' id=$category->id}">Все статьи</a>
                    </div>

                    <div class="blog-block__grid">
                        {foreach $categoriesPosts[$category->id] as $post}
                            <div class="blog-block__grid_item">
                                <div class="blog-block__grid_item__views">
                                    <img src="/images/views.svg" alt="">
                                    <span>{$post->views}</span>
                                </div>
                                <img src="{$post->image_path}" alt="">
                                <div>
                                    <h3>{$post->title}</h3>
                                    <span>{$post->created_at}</span>
                                    <p>{$post->description}</p>
                                    <a href="{route name='post-show' id=$post->id}">Подробнее...</a>
                                </div>
                            </div>
                        {/foreach}
                    </div>
                </div>
            </div>
        </section>
    {/foreach}
{/block}