<section class="content_article">

    <div class="article_full">
        <div class="article_image">
            <img src="/images/articles_images/{IMAGE}" alt="">

            <div class="my_list_cont">
                <div class="my_list">
                    <button class="my_list_button">Добавить в список <sup style="font-size: 12px">test</sup></button>
                </div>
                <div class="favourite">
                    <button onclick="Do_Favourite()" id="favourite" class="favourite_button {MY_LIST}"></button>
                </div>
            </div>

            {RATING_ARTICLE}

        </div>

        <div class="article_info">
            <div class="info_key">Название:</div><div class="info_value">{TITLE}</div>
            <div class="info_key">Оригинальное название:</div><div class="info_value">{TITLE_ENG}</div>
            <div class="info_key">Категория:</div><div class="info_value">{CATEGORY}</div>
            <div class="info_key">Автор:</div><div class="info_value">{ID_AUTHOR}</div>
            <div class="info_key">Дата добавления:</div><div class="info_value">{DATE}</div>
            <div class="info_key">Описание: </div><div class="description_value">{DESCRIPTION}</div>
        </div>
    </div>

    <div class="comments_cont">
        <div class="comments_title">РЕКОМЕНДАЦИИ:</div>
            <div class="recommendations">
                {RECOMMENDATIONS}
            </div>
    </div>

    <div class="comments_cont">
        <div class="comments_title">РЕЦЕНЗИИ:</div>
        {COMMENTS}
    </div>

    {ADD_COMMENT}

    <script type="text/javascript" src="/AJAX/Full_Article.js"></script>
</section>

