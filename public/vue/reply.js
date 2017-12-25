/**
 * Created by Administrator on 2017/11/30.
 */
reply = Vue.component('reply', function (success, error) {
    axios.get("/public/tpl/reply.html").then(function (res) {
        success({
            template: res.data,
            props: ['comment', 'niming', 'sex'],
            data(){
                return {

                }
            },
            methods:{
                back: function(){
                    window.history.go(-1);
                }
            },
            mounted: function(){
                console.log('sex' + this.sex);
                console.log('niming' + this.niming);
                console.log('comment' + this.comment);
            }
        });
    });
});