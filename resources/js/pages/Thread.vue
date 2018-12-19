<script>
    import Replies from '../components/thread/Replies';

    export default {
        // props: [count],
        props: ['thread'],

        components: {Replies},

        data() {
            return {
                data: this.thread,
                repliesCount: this.thread.replies_count,
            };
        }
    }
</script>
