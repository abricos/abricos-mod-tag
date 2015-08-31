var Component = new Brick.Component();
Component.requires = {
    yui: ['autocomplete', 'autocomplete-filters'],
    mod: [
        {name: '{C#MODNAME}', files: ['lib.js']}
    ]
};
Component.entryPoint = function(NS){

    var Y = Brick.YUI,
        COMPONENT = this,
        SYS = Brick.mod.sys;

    var tags = [
        'css',
        'css3',
        'douglas crockford',
        'ecmascript',
        'html',
        'html5',
        'java',
        'javascript',
        'json',
        'node.js',
        'pie',
        'yui'
    ];

    NS.TagListEditorWidget = Y.Base.create('tagListEditorWidget', SYS.AppWidget, [], {
        onInitAppWidget: function(err, appInstance){
            // appInstance.tagList();
            var tp = this.template,
                editorNode = tp.one('editor'),
                instance = this;
            
            editorNode.plug(Y.Plugin.AutoComplete, {
                allowTrailingDelimiter: true,
                minQueryLength: 0,
                queryDelay: 0,
                queryDelimiter: ',',
                source: function(query, callback){
                    instance.tagListByQuery(query, callback);
                },
                resultHighlighter: 'startsWith',

                resultFilters: ['startsWith', function (query, results) {
                    var selected = editorNode.get('value').split(/\s*,\s*/);

                    selected = Y.Array.hash(selected);

                    return Y.Array.filter(results, function (result) {
                        return !selected.hasOwnProperty(result.text);
                    });
                }]
            });
        },
        destructor: function(){
        },
        tagListByQuery: function(query, callback){
            var config = {
                query: query
            };
            this.get('appInstance').tagListByQuery(config, function(err, result){
                callback();
            });
        },
        toJSON: function(){
            return {};
        }
    }, {
        ATTRS: {
            component: {value: COMPONENT},
            templateBlockName: {value: 'widget'},
            ownerid: {value: 0},
            ownerType: {value: ''}
        }
    });
};