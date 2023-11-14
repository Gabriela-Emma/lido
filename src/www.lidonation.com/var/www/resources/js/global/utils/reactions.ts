export default function globalReactions(counts) {
    return {
        reactionsCount: counts,

        async addReaction(reaction, id) {
            let data = {
                comment: reaction
            }
            const res = await window.axios.post(`/react/post/${id}`, data);
            this.reactionsCount = res.data;
        },
    }
}
