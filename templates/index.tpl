{extends file='layouts/main.tpl'}


{block name="content"}

    {section name=row loop=$categories}
        <section>
            <div class="container">
                <div class="blog-block">
                    <div class="blog-block__top">
                        <h2>{$categories[row]->title}</h2>
                        <a href="/category/{$categories[row]->id}">Все статьи</a>
                    </div>

                    <div class="blog-block__grid">
                        {section name=postRow loop=$categoriesPosts[$categories[row]->id]}
                            <div class="blog-block__grid_item">
                                <img src="{$categoriesPosts[$categories[row]->id][postRow]->image_path}" alt="">
                                <div>
                                    <h3>{$categoriesPosts[$categories[row]->id][postRow]->title}</h3>
                                    <span>{$categoriesPosts[$categories[row]->id][postRow]->created_at}</span>
                                    <p>{$categoriesPosts[$categories[row]->id][postRow]->description}</p>
                                    <a href="/post/{$categoriesPosts[$categories[row]->id][postRow]->id}">Подробнее...</a>
                                </div>
                            </div>
                        {/section}
                    </div>
                </div>
            </div>
        </section>
    {/section}
{/block}