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

    NS.TagListEditorWidget = Y.Base.create('tagListEditorWidget', SYS.AppWidget, [], {
        onInitAppWidget: function(err, appInstance){
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
                resultFilters: ['startsWith', function(query, results){
                    var selected = editorNode.get('value').split(/\s*,\s*/);

                    selected = Y.Array.hash(selected);

                    return Y.Array.filter(results, function(result){
                        return !selected.hasOwnProperty(result.text);
                    });
                }]
            });
            editorNode.set('value', this.get('sTags'));
        },
        destructor: function(){
        },
        tagListByQuery: function(query, callback){
            var config = {
                query: query
            };
            this.get('appInstance').tagListByQuery(config, function(err, result){
                var tags = [];
                if (!err){
                    tags = result.tagListByQuery;
                }
                callback(tags);
            });
        },
        toJSON: function(){
            return {
                tags: this.get('tags')
            };
        }
    }, {
        ATTRS: {
            component: {value: COMPONENT},
            templateBlockName: {value: 'widget'},
            ownerid: {value: 0},
            ownerType: {value: ''},
            tags: {
                lazyAdd: true,
                validator: Y.Lang.isArray,
                value: [],
                setter: function(val){
                    var node = this.template.one('editor');
                    if (node){
                        node.set('value', val.join(', '));
                    }
                    return val;
                },
                getter: function(val){
                    var node = this.template.one('editor');
                    if (node){
                        return node.get('value').split(',');
                    }
                    return val;
                }
            },
            sTags: {
                validator: Y.Lang.isString,
                getter: function(){
                    return this.get('tags').join(', ');
                },
                setter: function(val){
                    this.set('tags', val.split(','));
                }
            }
        }
    });
};