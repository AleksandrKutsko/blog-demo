{extends file='layouts/main.tpl'}


{block name="content"}
    <section>
        <div class="container">
            <div class="blog-block">
                <div class="blog-block__top">
                    <div class="blog-block__top_title">
                        <h2>{$post->title}</h2>
                        <p><strong>Просмотров: {$post->views}</strong></p>
                        <p>{$post->description}</p>
                    </div>
                    <a href="{route name='main-page'}">На главную</a>
                </div>

                <div class="article-content">
                    <img src="{$post->image_path}" alt="">

                    {$post->content}
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="blog-block">
                <div class="blog-block__top">
                    <h2>Похожие посты</h2>
                </div>

                <div class="blog-block__grid">
                    {foreach $relatedPosts as $post}
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
{/block}