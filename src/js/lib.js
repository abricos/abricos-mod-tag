var Component = new Brick.Component();
Component.requires = {
    mod: [
        {name: 'sys', files: ['application.js']},
        {name: '{C#MODNAME}', files: ['model.js']}
    ]
};
Component.entryPoint = function(NS){

    NS.roles = new Brick.AppRoles('{C#MODNAME}', {
        isAdmin: 50
    });

    NS.Application = {
        ATTRS: {
            Tag: {value: NS.Tag},
            TagList: {value: NS.TagList}
        },
        REQS: {
            tagList: {
                attribute: false,
                args: ['owner', 'ownerid']
            },
            tagListByQuery: {
                attribute: false,
                /**
                 * Config example: {
                 *  query
                 * }
                 */
                args: ['config']
            }
        }
    };
};