declare namespace App.DataTransferObjects {
export type AnswerResponseData = {
id: number | null;
user_id: number | null;
question_id: number | null;
quiz_id: number | null;
question_answer_id: number | null;
stake_address?: string | null;
};
export type AssetDetailsData = {
asset_name: string;
divisibility: number;
metadata: App.DataTransferObjects.AssetMetaData | null;
};
export type AssetMetaData = {
logo: string | null;
ticker: string | null;
};
export type LearningLessonData = {
hash: string;
title: string;
content: string;
length: number | null;
order: number | null;
completed?: boolean | null;
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
status: string | null;
asset_details: App.DataTransferObjects.AssetDetailsData | null;
memo: string | null;
};
}
