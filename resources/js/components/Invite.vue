<template>
    <div>
        <section class="hero is-primary">
            <div class="hero-body">
                <div class="container">
                    <h1 class="title">
                        Invite
                    </h1>
                    <h2 class="subtitle">
                        Invite your friend to play this game.
                    </h2>
                </div>
            </div>
        </section>
        <div class="container">
            <div class="content mt-45">
                <div class="columns is-centered">
                    <div class="column is-half">
                        <div class="card">
                            <div class="card-content">
                                <form action="">
                                    <div class="field dropdown" :class="{'is-active': isDropdownShow}">
                                        <div class="control has-icons-left has-icons-right" :class="{'is-loading': isLoading}">
                                            <input v-model="user.name" @focus="isDropdownShow = true" class="input is-large" type="text" placeholder="Type your friend name to play ">
                                            <span class="icon is-small is-left">
                                      <i class="fa fa-users fa-xs"></i>
                                    </span>
                                        </div>
                                        <div v-if="user.lists.length" class="dropdown-menu users-dropdown" role="menu">
                                            <div class="dropdown-content">
                                                <a href="#" @click="sendInvitation(u)" v-for="u in user.lists" class="dropdown-item is-flex">
                                                    <figure class="image image is-48x48 mb-0">
                                                        <img class="is-rounded" :src="u.avatar.small" :alt="u.name">
                                                    </figure>
                                                    <span>
                                                        {{ u.name }} <br>
                                                        <i>- {{ u.email}}</i>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</template>

<script>
    import _ from 'lodash'

    export default {
        data(){
            return {
                user: {
                    name: '',
                    lists: []
                },
                isLoading: false,
                isDropdownShow: false
            }
        },
        methods: {
            sendInvitation(user){
                this.isDropdownShow = false;
                window.axios.post('invite', user).then(({ data }) => {
                    location.href = data.gameUrl;
                })
            }
        },
        watch: {
            "user.name" : _.debounce(function (name) {
                if(name){
                    this.isLoading = true

                    window.axios.get('/users', {
                        params: {
                            name
                        }
                    }).then(({ data }) => {
                        this.isLoading = false;

                        this.user.lists = data.data
                    })
                }
            }, 500)
        }
    }
</script>

<style lang="scss">
    .users-dropdown{
        width: 100%;
    }
    .image.mb-0{
        margin-bottom: 0 !important;
        margin-left: 0 !important;
    }
</style>