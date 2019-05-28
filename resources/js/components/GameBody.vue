<template>
    <div class="columns">
        <div class="column is-8">
            <div class="game-container">
                <span class="line top-left-to-bottom-right"></span>
                <span class="line top-right-to-bottom-left"></span>
                <span class="line middle-left-to-middle-right"></span>
                <span class="line middle-top-to-middle-bottom"></span>

                <span v-for="(dot, index) in paths" :class="{ 'selected': selectedIndex === index }" @click="pointClicked(dot, index)" :style="dot.styles" class="top-left point"></span>
            </div>
        </div>
        <div class="column is-4">
            <div class="card mt-40">
                <header class="card-header">
                    <p class="card-header-title">
                        Conversation
                    </p>
                </header>
                <div class="card-content p-0">
                    <div class="content">
                        <div class="chat-box p-20">
                            <ul class="chat-messages m-0">
                                <li class="chat-message is-clearfix replies">
                                    <p>Lorem ipsum dolor</p>
                                    <img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="">
                                </li>

                                <li class="chat-message is-clearfix send">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium adipisci aperiam asperiores aspernatur culpa cumque debitis eum facilis fugit impedit ipsum, iure, molestiae neque optio quisquam saepe ullam unde voluptas!</p>
                                    <img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="">
                                </li><li class="chat-message is-clearfix send">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium adipisci aperiam asperiores aspernatur culpa cumque debitis eum facilis fugit impedit ipsum, iure, molestiae neque optio quisquam saepe ullam unde voluptas!</p>
                                    <img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="">
                                </li><li class="chat-message is-clearfix replies">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium adipisci aperiam asperiores aspernatur culpa cumque debitis eum facilis fugit impedit ipsum, iure, molestiae neque optio quisquam saepe ullam unde voluptas!</p>
                                    <img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="">
                                </li>
                            </ul>
                            <form action="">
                                <div class="field">
                                    <div class="control has-icons-right">
                                        <textarea class="textarea" rows="3" placeholder="Write your message"></textarea>
                                        <span class="icon is-right send-button">
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
    import dots from '../dots'

    export default {

        data(){
            return {
                paths: paths,
                selectedIndex: undefined,
                dots: dots
            }
        },

        mounted() {

        },
        computed: {

        },
        methods: {
            pointClicked(dot, index){

                this.selecting(index)

            },
            selecting(index){

                if(index === this.selectedIndex){

                    this.selectedIndex = undefined

                    return;
                }

                this.selectedIndex = index
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
    .game-container{
        top: 50px;
        height: 600px;
        width: 600px;
        background-color: #ddd;
        margin: auto;
        position: relative;
        margin-bottom: 50px;
        border: 10px solid #2c3e50;
        .point{
            width: $circleRadius;
            height: $circleRadius;
            background-color: #fff;
            display: block;
            position: absolute;
            border-radius: 50%;
        }

        .line{
            position: absolute;
            display: block;
            background-color: #2c3e50;
        }

        .line.top-left-to-bottom-right{
            transform: rotate(-45deg);
            width: $line-width;
            height: 822px;
            left: 0;
            top: 4px;
            transform-origin: top;
        }

        .line.top-right-to-bottom-left{
            transform: rotate(45deg);
            width: $line-width;
            height: 822px;
            transform-origin: top;
            top: 5px;
            right: 0;
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
        .point.selected{
            transform: scale(1.2);
        }
    }
    .chat-box{
        .chat-messages{
            list-style-type: none;
            margin: 0;
            .chat-message{
                position: relative;
                margin-bottom: 15px;
                p{
                    max-width: 250px;
                    padding: 10px;
                    border-radius: 10px;
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
        background-color: #ddd;

        .input-box{

        }
    }

</style>
