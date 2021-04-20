{% set download_url = url({'for':'home.chapter.resources','id':chapter.id}) %}
{% set like_url = url({'for':'home.chapter.like','id':chapter.id}) %}
{% set like_title = chapter.me.liked == 1 ? '取消点赞' : '点赞支持' %}
{% set like_class = chapter.me.liked == 1 ? 'active' : '' %}

<div class="toolbar-sticky">
    <div class="item">
        <div class="icon" title="{{ like_title }}" data-url="{{ like_url }}">
            <i class="layui-icon layui-icon-praise icon-praise {{ like_class }}"></i>
        </div>
        <div class="text">{{ chapter.like_count }}</div>
    </div>
    <div class="item" id="toolbar-online">
        <div class="icon" title="在线人数">
            <i class="layui-icon layui-icon-user"></i>
        </div>
        <div class="text">0</div>
    </div>
    {% if chapter.resource_count > 0 %}
        <div class="item">
            <div class="icon" title="学习资料" data-url="{{ download_url }}">
                <i class="layui-icon layui-icon-download-circle icon-download"></i>
            </div>
            <div class="text">资料</div>
        </div>
    {% endif %}
</div>