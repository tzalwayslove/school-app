/**
 * Created by Administrator on 2017/11/30.
 */
pinglun = Vue.component('pinglun', function (success, error) {
    axios.get("/public/tpl/pinglun.html").then(function (res) {
        success({
                template: res.data,
                props: ['articel'],
                data(){
                    return {
                        list: []
                    }
                },
                mounted: function () {
                    let id =this.$route.params.id;
                    console.log(1111111111);
                    axios.get('wx/comment/'+ id).then(function(res){
                        console.log(this.data);
                        this.list = res.data.list;
                    });
                }
            }
        );
    });
});