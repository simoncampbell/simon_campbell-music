{exp:weblog:entries
    entry_id="{embed:entry_id}"
    disable="categories|trackbacks|pagination"
    weblog="products_music"
}
<span class="item music_file">
    <a href="{exp:cartthrob:get_download_link
        file='{cf_products_music_{embed:download_format}}'
        member_id ='{logged_in_member_id}'}">
        {embed:download_format_text}
    </a>
</span>
{/exp:weblog:entries}