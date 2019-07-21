<template>
    <div class="columns">
        <div class="column is-8">
            <div class="has-text-centered">
                <h4>
                    <span v-if="!gameData.winner_id" class="active-status" :class="isTimeToTurn ? 'active': 'inactive'"></span>
                    {{ whoCanTurnDot }}</h4>
            </div>

            <div class="game-container" :class="{'play-as-opponent': !isPlayAsOpponent, 'is-loading': isLoading}">
                <span class="line top-left-to-bottom-right activated"></span>
                <span class="line top-right-to-bottom-left"></span>
                <span class="line middle-left-to-middle-right"></span>
                <span class="line middle-top-to-middle-bottom"></span>

                <span v-for="(dot, index) in paths"
                      :class="{
                            selected: selectedIndex === index,
                            'available-highlight': (availablePath.indexOf(index) !== -1 && !getDot(index)),
                            'dot-highlight': (getDot(index) ? (meId === getDot(index).user_id && selectedIndex === undefined && isTimeToTurn && !gameData.winner_id) : false)
                      }"
                      @click="pointClicked(dot, index)"
                      :style="styles(index)" class="top-left point">
                </span>
            </div>
        </div>
        <div class="column is-4">
            <div class="card mt-40 is-rounded">
                <header class="card-header">
                    <p class="card-header-title">
                        Conversation <span class="active-status ml-5" :class="isActiveOpponent ? 'active' : 'inactive'"></span>
                    </p>
                </header>
                <div class="card-content p-0">
                    <div class="content">
                        <audio src="/audio/new-message.mp3" muted ref="messageSound"></audio>
                        <div class="chat-box p-20">
                            <ul class="chat-messages m-0" v-chat-scroll="{always: false, smooth: true}">
                                <li v-for="message in messages" :class="meId === message.user_id ? 'send' : 'replies'" class="chat-message is-clearfix">
                                    <p>{{ message.message }}</p>
                                    <img :title="message.user.name" :src="message.user.avatar" :alt="message.user.name">
                                </li>
                            </ul>
                            <form>
                                <div class="field">
                                    <div class="control has-icons-right">
                                        <textarea v-model="message" @keyup.enter="sendMessage" class="textarea" rows="3" placeholder="Write your message"></textarea>
                                        <span @click="alert('message')" class="icon is-right send-button">
                                          <i class="fa fa-paper-plane fa-sm" ></i>
                                        </span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>

    import paths from '../paths'
    // import dots from '../dots'

    export default {
        props: {
            gameUsers: Array,
            meId: Number,
            game: Object
        },
        data(){
            return {
                paths: paths,
                selectedIndex: undefined,
                dots: [],
                users: [],
                gameData: {},
                message: '',
                messages: [],
                isLoading: false
            }
        },
        computed: {
            channel(){
                return window.Echo.join(`game.${this.game.id}`)
            },
            availablePath() {
                if (this.selectedIndex === undefined) {
                    return [];
                }
                return this.paths[this.selectedIndex].availablePath;
            },
            me() {
                return this.gameUsers.find((u) => {
                    return u.id === this.meId
                })
            },
            opponent() {
                return this.gameUsers.find((u) => {
                    return u.id !== this.meId
                });
            },
            isTimeToTurn() {
                return this.gameData.turnner_id === this.meId
            },
            whoCanTurnDot(){
                return this.isTimeToTurn ? 'Your Turn' : 'Opponent\'s Turn';
            },
            isPlayAsOpponent() {
                return this.game.user_id !== this.meId
            },
            isActiveOpponent() {
                return Boolean(this.users.find((u) => u.id === this.opponent.id));
            },
            isEnd() {
                return Boolean(this.gameData.is_end);
            }
        },

        mounted() {
            this.gameData = this.game;
            this.getDefaultMoves();
            this.getMessages();
            this.channel
                .here((users) => {
                    this.users = users
                }).joining((user) => {
                    this.users.push(user)
                }).leaving((user) => {
                    this.users.splice(this.users.indexOf(u => u.id === user.id), 1);
                }).listen('NewMessageEvent', (e) => {
                    this.messages.push(e.data.message);
                if(e.data.message.user_id !== this.meId) {
                        this.playNewMessageSound();
                    }
                }).listen('GameMoveEvent', ({ data }) => {
                    const prevDot = this.getDot(data.previousIndex);
                    this.selectedIndex = undefined;
                    prevDot.index = data.move.index;
                    this.gameData.turnner_id = data.turnner_id
                }).listenForWhisper('typing', (e) => {
                    console.log(e)
                })
        },
        methods: {
            pointClicked(dot, index) {
                if(!this.isTimeToTurn) {
                    return;
                }
                const findDot = this.getDot(index);

                if(!findDot && this.selectedIndex === undefined) {
                    return;
                }


                if (this.selectedIndex === undefined) {
                    if(findDot.user_id !== this.meId) {
                        return;
                    }
                    return this.selectedIndex = index;
                }

                if (this.selectedIndex === index) {
                    this.selectedIndex = undefined;
                }else {
                    this.turnDot(dot, index);
                }
            },
            styles(index){
                const dot = this.dots.find(d => d.index === index);

                if(dot){
                    return {
                        ...this.paths[index].styles,
                        backgroundColor: (this.game.user_id === dot.user_id ? '#1dd1a1' : 'orange')
                    };
                }

                return this.paths[index].styles
            },
            typing(e){
                this.channel.whisper('typing', {

                })
            },
            getDot(index) {
                return this.dots.find((d) => {
                    return d.index === index
                });
            },
            turnDot(dot, index) {
                const previousDot = this.getDot(this.selectedIndex);
                const targetDot = this.getDot(index);

                if (this.availablePath.indexOf(index) !== -1 && !targetDot) {
                    this.isLoading = true;
                    window.axios.put(`/games/${this.gameData.id}/moves/${previousDot.id}`, {
                        index,
                        dot
                    }).then(() => {



                        this.isLoading = false;
                    });
                }
            },
            getDefaultMoves() {
                window.axios.get(`/games/${this.gameData.id}/moves`).then(({ data }) => {
                    this.dots = data;
                })
            },
            sendMessage() {
                if(!this.message) {
                    return;
                }

                window.axios.post(`/games/${this.game.id}/messages`, {
                    message: this.message
                });

                this.message = '';

            },
            getMessages(){
                window.axios.get(`/games/${this.game.id}/messages`).then(({ data }) => {
                    this.messages = data;
                });
            },
            playNewMessageSound() {
                this.$refs.messageSound.play();
            },
            checkingIfPathMatch() {
                
            }
        }
    }
</script>


<style lang="scss">
    $line-width: 10px;
    $circleRadius: 30px;
    .send-button{
        cursor: pointer;
    }
    .game-container {
        &.is-loading{
            &:after{
                content: '';
                position: absolute;
                left: -10px;
                top: -10px;
                width: calc(100% + 20px);
                height: calc(100% + 20px);
                background-color: rgba(255, 255, 255, 0.5);
                z-index: 9;
            }

            &:before{
                content: 'Loading';
                position: absolute;
                left: 50%;
                top: 50%;
                z-index: 99999;
                font-size: 25px;
                transform: translate(-50%);
            }
        }
        &.is-loading.play-as-opponent {
            &:before{
                transform: rotate(180deg) translate(50%);
            }
        }
        top: 50px;
        height: 500px;
        width: 500px;
        background-color: #ddd;
        position: relative;
        margin: auto auto 50px;
        border: 10px solid #2c3e50;
        box-shadow: 0 0 8px 10px #ddd;
        transition: 0.6s;

        .line{
            position: absolute;
            display: block;
            background-color: #2c3e50;
            &.activated {
                background-color: #0fb9b1;
            }
        }

        .line.top-left-to-bottom-right{
            transform: rotate(-45deg);
            width: $line-width;
            height: 680px;
            left: -6px;
            top: 0;
            transform-origin: top;
        }

        .line.top-right-to-bottom-left{
            transform: rotate(45deg);
            width: $line-width;
            height: 680px;
            transform-origin: top;
            top: 0;
            right: -6px;
        }

        .line.middle-left-to-middle-right{
            width: 100%;
            height: $line-width;
            top: 50%;
            transform: translateY(-50%);
        }

        .line.middle-top-to-middle-bottom{
            width: $line-width;
            height: 100%;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
        }
        .point {
            width: $circleRadius;
            height: $circleRadius;
            background-color: transparent;
            display: block;
            position: absolute;
            border-radius: 50%;
            transition: transform 0.3s;

            &.selected{
                &:after {
                    content: '';
                    width: 100%;
                    height: 100%;
                    left: 0;
                    top: 0;
                    position: absolute;
                    border: 2px solid #fff;
                    border-radius: 50%;
                    transform: scale(0.9);
                }
                transform: scale(1.2);
                background-color: #ff6b6b !important;
            }
            &.available-highlight {
                background-color: #cd84f1;
                &:after {
                    content: '';
                    position: absolute;
                    left: 0;
                    height: 100%;
                    top: 0;
                    width: 100%;
                    background-color: #fff;
                    z-index: 9;
                    border-radius: 50%;
                    animation: pulse infinite 1s;
                }
            }
            &.dot-highlight{
                &:after{
                    content: '';
                    width: 100%;
                    height: 100%;
                    left: 0;
                    top: 0;
                    position: absolute;
                    background-color: transparent;
                    border-radius: 50%;
                    border: 3px solid transparent;
                    border-top-color: #fff;
                    border-bottom-color: #fff;
                    animation: spiny 3s linear infinite;
                }
            }

        }

        &.play-as-opponent {
            transform: rotate(180deg);
        }
    }
    .chat-box{
        .chat-messages{
            list-style-type: none;
            margin: 0;
            max-height: 350px;
            overflow: auto;
            .chat-message{
                position: relative;
                margin-bottom: 15px;
                p{
                    max-width: 250px;
                    padding: 6px 10px;
                    border-radius: 8px;
                    margin-bottom: 0;
                    display: inline-block;
                    font-size: 13px;
                }
                img{
                    position: absolute;
                    max-width: 30px;
                    height: 30px;
                    border-radius: 50%;
                }

                &.replies{
                    p{
                        background-color: #00d1b2;
                        color: #fff;
                        margin-left: 35px;
                    }

                    img{
                        bottom: 0;
                        left: 0;
                    }
                }
                &.send{
                    p{
                        background-color: #fff;
                        float: right;
                        text-align: right;
                        margin-right: 35px;
                    }
                    img{
                        right: 0;
                        bottom: 0;
                    }
                }
            }
        }
        background-color: #ddd6;
        overflow: auto;
    }

    .active-status {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        &.active {
            background-color: #00d1b2;
        }
        &.inactive {
            background-color: #ff6b6b;
        }
    }

    @keyframes pulse {
        0% {
            transform: scale(0);
            opacity: 1;
        }
        50% {
            opacity: 0.9;
        }
        100% {
            transform: scale(1.5);
            opacity: 0.1;
        }
    }

    @keyframes spiny {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

</style>
