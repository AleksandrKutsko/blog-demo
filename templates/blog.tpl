{extends file='layouts/main.tpl'}


{block name="content"}
    <section>
        <div class="container">
            <div class="blog-block">
                <div class="blog-block__top">
                    <div class="blog-block__top_title">
                        <h2>{$page_title}</h2>
                        <p>{$page_description}</p>
                    </div>
                    <a href="{route name='main-page'}">На главную</a>
                </div>

                <div class="blog-block__sort">
                    <p>Сортировка:</p>
                    <ul class="sort-list">
                        <li><a {if ($sort == 'created_at' && $order_by == 'desc')}class="current"{/if} href="?page={$current_page}&sort=created_at&order=desc">по дате(сначала новые)</a></li>
                        <li><a {if ($sort == 'created_at' && $order_by == 'asc')}class="current"{/if} href="?page={$current_page}&sort=created_at&order=asc">по дате(сначала старые)</a></li>
                        <li><a {if ($sort == 'views' && $order_by == 'desc')}class="current"{/if} href="?page={$current_page}&sort=views&order=desc">по просмотрам(сначала популярные)</a></li>
                        <li><a {if ($sort == 'views' && $order_by == 'asc')}class="current"{/if} href="?page={$current_page}&sort=views&order=asc">по просмотрам(сначала непопулярные)</a></li>
                    </ul>
                </div>

                <div class="blog-block__grid">
                    {foreach $posts as $post}
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

            {if $has_pagination}
            <ul class="blog-pagination">
                {for $i=1 to $total_pages}
                    <li><a {if $current_page == $i} class="current"{/if} href="?page={$i}&sort={$sort}&order={$order_by}">{$i}</a></li>
                {/for}
            </ul>
            {/if}
        </div>
    </section>
{/block}