<template>
    <div class="container mediaLibrary">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Media files list for website {{website.domain}}
                    </div>
                    <div class="panel-body" v-if="isLoading">
                        Идет обработка данных...пиу-пиу
                    </div>
                    <div class="panel-body" v-if="!isLoading">
                        <div class="mediaCollections">
                            <ul class="nav nav-pills">
                                <li role="presentation" :class="{'active':(activeCollection === collection.name)}" v-for="collection in collections">
                                    <a @click="selectCollection(collection)">
                                        {{collection.name}}
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="row mediaList">
                            <div class="col-xs-4 mediaList_item" v-for="item in getList()">
                                <div>ID: {{item.id}}</div>
                                <div>Collection: {{item.collection}}</div>
                                <img :src="item.thumb"/>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="mediaUploader">
                            <div class="form-group col-md-12">
                                <div>
                                    <h3>Uploading new attachments</h3>
                                </div>
                                <div class="col-md-12">
                                    <input type="file" multiple="multiple" id="attachments" @change="uploadFieldChange">
                                    <hr>
                                    <div class="col-md-12">
                                        <div class="attachment-holder animated fadeIn" v-cloak v-for="(attachment, index) in attachments">
                                            <span class="label label-primary">{{ attachment.name + ' (' + Number((attachment.size / 1024 / 1024).toFixed(1)) + 'MB)'}}</span>
                                            <span class="" style="background: red; cursor: pointer;" @click="removeAttachment(attachment)"><button class="btn btn-xs btn-danger">Remove</button></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <select class="form-control" v-model="uploadCollection" style="width: 100%;">
                                            <option :value="col.name" v-for="col in collections">{{col.name}}</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-6">
                                        <button class="btn btn-primary" @click="submit">Upload files</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['websiteId'],
        data() {
            return {
                isLoading: false,
                activeCollection: 'all',
                uploadCollection: null,
                collections: [],
                website: {
                    id: null,
                    name: null,
                    domain: null,
                    template_id: null
                },
                files: [],
                attachments: [],
                // Each file will need to be sent as FormData element
                data: new FormData(),
                errors: {
                },
                percentCompleted: 0,
            }
        },
        methods: {
            selectCollection(collection) {
                this.activeCollection = collection.name;
            },
            getAttachmentSize() {

                this.upload_size = 0; // Reset to beginningƒ
                this.attachments.map((item) => { this.upload_size += parseInt(item.size); });

                this.upload_size = Number((this.upload_size).toFixed(1));
                this.$forceUpdate();
            },
            prepareFields() {

                if (this.attachments.length > 0) {
                    for (var i = 0; i < this.attachments.length; i++) {
                        let attachment = this.attachments[i];
                        this.data.append('attachments[]', attachment);
                    }
                }
                this.data.append('collection', this.uploadCollection);
            },
            removeAttachment(attachment) {

                this.attachments.splice(this.attachments.indexOf(attachment), 1);

                this.getAttachmentSize();
            },
            // This function will be called every time you add a file
            uploadFieldChange(e) {
                var files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                for (var i = files.length - 1; i >= 0; i--) {
                    this.attachments.push(files[i]);
                }
                // Reset the form to avoid copying these files multiple times into this.attachments
                document.getElementById("attachments").value = [];
            },
            submit() {
                this.prepareFields();
                let _this = this;
                var config = {
                    headers: { 'Content-Type': 'multipart/form-data' } ,
                    onUploadProgress: function(progressEvent) {
                        this.percentCompleted = Math.round( (progressEvent.loaded * 100) / progressEvent.total );
                        this.$forceUpdate();
                    }.bind(this)
                };
                // Make HTTP request to store announcement
                axios.post('/api/media/' + this.websiteId + '/upload', this.data, config)
                    .then(function (response) {
                        console.log(response);
                        if (response.data.success) {
                            console.log('Successfull Upload');
                            _this.files = response.data.files;
                            this.resetData();
                        } else {
                            console.log('Unsuccessful Upload');
                            this.errors = response.data.errors;
                        }
                    }.bind(this)) // Make sure we bind Vue Component object to this funtion so we get a handle of it in order to call its other methods
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            // We want to clear the FormData object on every upload so we can re-calculate new files again.
            // Keep in mind that we can delete files as well so in the future we will need to keep track of that as well
            resetData() {
                this.data = new FormData(); // Reset it completely
                this.attachments = [];
            },
            start() {
                console.log('Starting File Management Component');
            },
            getList() {
                let _this = this;
                return _this.files.filter(function (item) {
                    if(_this.activeCollection === item.collection || _this.activeCollection === 'all') {
                        return true;
                    } else {
                        return false;
                    };
                })
            },

            save: function () {
                let _this = this;
                _this.isLoading = true;
                if(_this.isEditing) {
                    axios.put('/api/page/', {page: _this.page}).then(function (r) {
                        if(r.data.success) {
                            alert('success');
                        }
                        else {
                            alert('error');
                        }
                        _this.isLoading = false;
                    }).catch(function (e) {
                        alert('fail');
                        _this.isLoading = false;
                    });
                } else {
                    _this.page.website_id = _this.websiteId;
                    axios.post('/api/page/', {page: _this.page}).then(function (r) {
                        if(r.data.success) {
                            alert('success');
                            location.href = r.data.redirectUrl;
                        }
                        else {
                            alert('error');
                        }
                        _this.isLoading = false;
                    }).catch(function (e) {
                        alert('fail');
                        _this.isLoading = false;
                    });
                }
            },
        },
        created() {
            let _this = this;
            axios.get('/api/website/get/' + _this.websiteId).then(function (res) {
                _this.website = res.data.website;
            });
            axios.get('/api/media/' + _this.websiteId).then(function (res) {
                _this.files = res.data.files;
                _this.collections = res.data.collections;
                _this.uploadCollection = _this.collections[1].name;
            });
            _this.start();
        },
        mounted() {
        }
    }
</script>
