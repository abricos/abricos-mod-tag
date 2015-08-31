var Component = new Brick.Component();
Component.requires = {
    mod: [
        {name: 'sys', files: ['appModel.js']},
    ]
};
Component.entryPoint = function(NS){

    var Y = Brick.YUI,
        L = Y.Lang,
        SYS = Brick.mod.sys;

    NS.Tag = Y.Base.create('tag', SYS.AppModel, [], {
        structureName: 'Tag'
    });

    NS.TagList = Y.Base.create('tagList', SYS.AppModelList, [], {
        appItem: NS.Tag
    });
};