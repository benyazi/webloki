<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Создание сайта</div>
                    <div class="panel-body" v-if="isLoading">
                        Идет обработка данных...пиу-пиу
                    </div>
                    <div class="panel-body" v-if="!isLoading">
                        <form class="form-horizontal" onsubmit="return false;">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Название компании</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="name" placeholder="Сайт ООО Петрушка" v-model="website.name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="domain" class="col-sm-2 control-label">Домен сайта</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="domain" placeholder="site.site" v-model="website.domain">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="template" class="col-sm-2 control-label">Шаблон</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="template" v-model="website.template_id">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="button" class="btn btn-success btn-sm" @click="save()">Создать сайт</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [],
        data() {
            return {
                isLoading: false,
                website: {
                    id: null,
                    name: null,
                    domain: null,
                    template_id: null,
                }
            }
        },
        methods: {
            save: function () {
                let _this = this;
                _this.isLoading = true;
                axios.post('/api/website/add/', {website: _this.website}).then(function (r) {
                    if(r.data.success) {
                        location.href = r.data.redirectUrl;
                    }
                }).catch(function () {
                    _this.isLoading = false;
                });
            },
        },
        created() {},
        mounted() {
        }
    }
</script>
