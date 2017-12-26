/**
 * Created by Administrator on 2017/11/30.
 */
fabu = Vue.component('chengji', function (success, error) {
    axios.get("/public/tpl/chengji.html").then(function (res) {
        success({
            template: res.data,
            props: ['user'],
            data() {
                return {
                    jiazai: true,
                    chengji: [],
                    jige: [],
                    bujige: [],
                    selected: '',
                    options: [],

                }
            },
            computed: {
                GPA: function () {
                    xuefenjidian = 0;
                    xuefen = 0;
                    chengji = [];
                    console.log('-----------------------');
                    for (i = 0, len = this.chengji.length; i < len; ++i) {
                        this.chengji[i].xuefen = Number(this.chengji[i].xuefen);
                        this.chengji[i].jidian = Number(this.chengji[i].jidian);
                        xuefenjidian += this.chengji[i].xuefen * this.chengji[i].jidian;

                        if(!this.inArray(chengji , this.chengji[i].kechengbianhao)){
                            chengji.push(this.chengji[i].kechengbianhao);
                            xuefen += this.chengji[i].xuefen;
                            console.log(this.chengji[i].xuefen + ": " + this.chengji[i].kecengmingceng);
                        }
                    }
                    console.log(xuefen);

                    console.log(xuefenjidian);
                    return xuefen > 0
                        ? (xuefenjidian / xuefen).toFixed(2)
                        : 0;
                }
            },
            methods: {
                changePage: function () {
                    if(this.selected == ''){
                        return ;
                    }
                    if (this.selected == 'all') {
                        window.location.href = '/wx/chengji_all?user=' + this.user
                    } else {
                        this.jiazai = true;
                        this.getData();
                    }
                },
                inArray: function(arr, item){
                    for (var i = 0, len = arr.length; i < len; ++i) {
                        if(item == arr[i]){
                            return true;
                        }
                    }
                    return false;
                },
                getData: function () {
                    $this = this;
                    axios.get("/api/chengji?user=" + this.user + '&xueqi='+this.selected).then(function (res) {
                        $this.jiazai = false;
                        if (res.data.result.code == 0) {
                            alert(res.data.result.message || '获取失败!');
                        } else {
                            console.log(res.data.chengji);

                            $this.chengji = res.data.chengji;
                            $this.jige = $this.chengji.filter(function (item) {
                                return item.chengji >= 60 || item.chengji.indexOf('不及格') == -1;
                            });

                            $this.bujige = $this.chengji.filter(function (item) {
                                return item.chengji < 60;
                            });
                        }
                    });
                }
            },


            mounted: function () {
                $this = this;

                axios.get("/wx/getChengjiOptions?user=" + this.user).then(function (res) {
                    res = res.data;
                    if (res.result.code == 1) {
                        $this.options = res.options;
                    } else {
                        alert('请求数据失败，请重试！');
                    }
                });
                this.getData();

            }
        });
    });
});