/**
 * Created by Administrator on 2017/11/30.
 */
fabu = Vue.component('reply', function (success, error) {
    axios.get("/public/tpl/reply.html").then(function (res) {
        success({
            template: res.data,
            props: ['comment'],
            data(){
                return {

                }
            },
            methods:{
                back: function(){
                    window.history.go(-1);
                }
            }
        });
    });
});