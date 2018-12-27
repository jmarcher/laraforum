<script>
    import Replies from '../components/thread/Replies';
    import SubscribeButton from '../components/thread/SubscribeButton';

    export default {
        // props: [count],
        props: ['thread'],

        components: {Replies, SubscribeButton},

        data() {
            return {
                data: this.thread,
                repliesCount: this.thread.replies_count,
            };
        }
    }
</script>
