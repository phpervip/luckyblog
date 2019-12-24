// 以下代码是配置layui扩展模块的目录，每个页面都需要引入
layui.config({
    base:  local_url+ 'module/'
}).extend({
    authtree: 'authtree',
    soulTable: 'soultable/soulTable',
    treeTable: 'treeTable/treeTable',
    inputTags: 'inputTags/inputTags',
    IconFonts: 'iconFonts/iconFonts',
    iconPicker:'iconPicker/iconPicker',
    notice: 'notice/notice',
    comm:'comm',
    lucky: 'lucky',
});
