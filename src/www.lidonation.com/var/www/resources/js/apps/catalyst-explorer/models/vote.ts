export default interface Vote {
    id: number;
    user_id: number;
    proposal_id: number;
    vote: number;
    created_at: string;
    updated_at: string;
    content: string;
  }
