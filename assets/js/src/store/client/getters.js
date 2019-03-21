export const HAS_PENDING_REQUESTS = 'hasPendingRequests';
export const PENDING_REQUESTS_NUM = 'pendingRequestsNum';

export default {
    [HAS_PENDING_REQUESTS] : (state) => {
        return !!state.pending.length;
    },
    [PENDING_REQUESTS_NUM] : (state) => {
        return state.pending.length;
    }
};
