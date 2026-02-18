{extends file='layouts/main.tpl'}


{block name="content"}
    <section>
        <div class="container">
            <div class="blog-block">
                <div class="blog-block__top">
                    <div class="blog-block__top_title">
                        <h2>{$page_title|default:'Ошибка'}</h2>
                        <p>{$page_description}</p>
                    </div>
                    <a href="/">На главную</a>
                </div>
            </div>
        </div>
    </section>
{/block}