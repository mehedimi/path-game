<script>
    import swal from 'sweetalert'
    import speech from 'speech-js'

    export default {
        props: [
            'userId'
        ],
        mounted() {
            window.Echo.private(`users.${this.userId}`)
                .listen('InviteEvent', ({ game }) => {
                    const message = `${game.user.name} is invite to you play game with him. `;
                    this.outputAsAudio(message);
                    swal({
                        title: 'Invitation!',
                        text: message,
                        closeOnClickOutside: false,
                        buttons: {
                            accept: {
                                text: 'Accept',
                                value: 'accept'
                            },
                            reject: {
                                text: 'Reject',
                                value: 'reject',
                                className: 'swal-button--danger'
                            }
                        }
                    }).then((button) => {
                        switch (button) {
                            case 'accept':
                                location.href = `/play/${game.id}`;
                                break;
                            case 'reject':

                                break;
                        }
                    });
                })
        },
        render(createElement, context) {

        },
        methods: {
            outputAsAudio(message) {
                speech.synthesis(message + ' Do you accept? or reject?', 'en-US');
            }
        }
    }
</script>
