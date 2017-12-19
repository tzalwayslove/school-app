/**
 * Created by Administrator on 2017/12/12.
 */
$.extend({
    postData:function(url, data, success, err){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            url:url,
            data:data,
            type:'post',
            success: success,

            error: function(res){
                if(err){
                    if(err()){
                        if(res.status == 422){
                            str = "";
                            $.each(res.responseJSON, function(k,v){
                                str += v + ",";
                            });
                            try {
                                layer.alert(str);
                            }catch(exception){
                                alert(str);
                            }
                        }
                    }
                }else{
                    if(res.status == 422){
                        str = "";
                        $.each(res.responseJSON, function(k,v){
                            str += v + ",";
                        });
                        try {
                            layer.alert(str);
                        }catch(exception){
                            alert(str);
                        }
                    }
                }

            }
        });
    },
    getData:function(url, data, success, err){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            url:url,
            data:data,
            type:'get',
            success: success,

            error: function(res){
                if(err){
                    if(err()){
                        if(res.status == 422){
                            str = "";
                            $.each(res.responseJSON, function(k,v){
                                str += v + ",";
                            });
                            try {
                                layer.alert(str);
                            }catch(exception){
                                alert(str);
                            }
                        }
                    }
                }else{
                    if(res.status == 422){
                        str = "";
                        $.each(res.responseJSON, function(k,v){
                            str += v + ",";
                        });
                        try {
                            layer.alert(str);
                        }catch(exception){
                            alert(str);
                        }
                    }
                }

            }
        });
    },

    log:function(info){
        console.log(info);
    },
    alert:function(str){
        try{
            layer.alert(str);
        }catch(e){
            alert(str);
        }
    },
    confirm:function(str, success, err){
        try {
            var index = layer.confirm(str, function(index){
                success();
                layer.close(index);
            }, err);

        } catch (e){
            var res = confirm(str);
            if(res){
                success();
            }else{
                err();
            }
        }
    },
    msg:function(msg){
        try {
            layer.msg(msg);
        }catch(e){
            alert(msg)
        }
    }
});