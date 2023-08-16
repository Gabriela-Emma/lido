declare namespace App.DataTransferObjects {
export type AnswerResponseData = {
id: number;
userId: number | null;
questionAnswerId: number | null;
createdAt?: any;
correct: boolean | null;
question: App.DataTransferObjects.QuizQuestionData | null;
quiz: App.DataTransferObjects.QuizData | null;
answer: App.DataTransferObjects.QuizQuestionAnswerData | null;
stake_address?: string | null;
};
export type AssetDetailsData = {
asset_name: string | null;
divisibility: number | null;
metadata: App.DataTransferObjects.AssetMetaData | null;
};
export type AssetMetaData = {
logo: string | null;
ticker: string | null;
};
export type CatalystRegistrationData = {
id: number | null;
tx: string | null;
voting_power: string | null;
stake_pub: string | null;
created_at?: string | null;
};
export type CommentData = {
id: number | null;
title: string | null;
text: string;
status?: string | null;
createdAt?: any;
};
export type CommunityReviewData = {
id: number | null;
title: string | null;
content: string;
status?: string | null;
comments: Array<App.DataTransferObjects.CommentData> | null;
};
export type LearnerData = {
name: string | null;
active_pool_id: string | null;
wallet_address?: string | null;
email: string | null;
wallet_stake_address?: string | null;
nextLessonAt?: string | null;
nextLesson?: App.DataTransferObjects.LearningLessonData | null;
totalRewardSum?: number | null;
availableRewards?: Array<App.DataTransferObjects.RewardData> | null;
completed_topics: Array<App.DataTransferObjects.LearningTopicData> | null;
};
export type LearningAttemptData = {
retryAt?: any;
nextLessonAt?: any;
response?: App.DataTransferObjects.AnswerResponseData | null;
quiz?: App.DataTransferObjects.QuizData | null;
module?: App.DataTransferObjects.LearningModuleData | null;
topic?: App.DataTransferObjects.LearningTopicData | null;
lesson?: App.DataTransferObjects.LearningLessonData | null;
};
export type LearningLessonData = {
hash: string;
title: string;
content: string;
length: number | null;
order: number | null;
completed?: boolean | null;
retryAt?: any;
nextLessonAt?: any;
nextLesson?: App.DataTransferObjects.LearningLessonData | null;
link?: string | null;
quiz?: App.DataTransferObjects.QuizData | null;
quizzes: Array<App.DataTransferObjects.QuizData> | null;
model?: App.DataTransferObjects.ModelData | null;
topic?: App.DataTransferObjects.LearningTopicData | null;
};
export type LearningModuleData = {
id: number;
title: string;
content?: string | null;
link: string;
length: number | null;
lessons_count: number | null;
topics_count: number | null;
model: Array<any> | null;
metadata: Array<any> | null;
topics: Array<App.DataTransferObjects.LearningTopicData> | null;
};
export type LearningTopicData = {
id: number;
title: string;
content: string | null;
length: number | null;
link: string;
lessons_count: number | null;
lessons: Array<App.DataTransferObjects.LearningLessonData> | null;
};
export type ModelData = {
id: number | null;
slug: string | null;
title: string | null;
content: string | null;
type: string | null;
link?: string | null;
};
export type PostData = {
title: string | null;
id: number | null;
author_name: string | null;
author_gravatar: string | null;
link: string | null;
published_at: string | null;
read_time: string | null;
};
export type PostSearchResultData = {
type: string | null;
items: Array<App.DataTransferObjects.PostData> | null;
};
export type PromoData = {
title: string | null;
uri: string | null;
feature_url: string | null;
content: string | null;
};
export type ProposalData = {
id: number | null;
title: string | null;
link: string;
status?: string | null;
};
export type ProposalRatingData = {
id: number | null;
rationale: string;
rating: string;
meta_data: any;
proposal: App.DataTransferObjects.ProposalData;
community_review: App.DataTransferObjects.CommunityReviewData;
status?: string | null;
};
export type QuizData = {
id: number | null;
title: string;
content: string;
status?: string | null;
questions: Array<App.DataTransferObjects.QuizQuestionData> | null;
};
export type QuizQuestionAnswerData = {
id: number | null;
title: string | null;
content?: string | null;
correct?: boolean | null;
correctness?: string | null;
hint?: string | null;
status?: string | null;
type?: string | null;
question?: App.DataTransferObjects.QuizQuestionData | null;
};
export type QuizQuestionData = {
id: number | null;
title: string | null;
content?: string | null;
type?: string | null;
status?: string | null;
answers: Array<App.DataTransferObjects.QuizQuestionAnswerData> | null;
};
export type RewardData = {
id: number | null;
asset: string | null;
amount: number | null;
asset_type?: string | null;
created_at?: string | null;
status: string | null;
asset_details?: App.DataTransferObjects.AssetDetailsData | null;
memo: string | null;
};
export type TxData = {
id: number | null;
policy: string | null;
hash: string | null;
address: string | null;
status: string | null;
quantity: string | null;
created_at?: string | null;
};
export type WithdrawalData = {
id: number | null;
status: string | null;
rewards_count: number | null;
created_at?: string | null;
txs?: Array<App.DataTransferObjects.TxData> | null;
withdrawal_tx?: string | null;
amounts?: any | null;
rewards?: Array<App.DataTransferObjects.RewardData> | null;
};
}
