declare namespace App.DataTransferObjects {
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
title: string;
content: string;
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
type?: string | null;
status?: string | null;
};
export type QuizQuestionData = {
id: number | null;
title: string;
content?: string | null;
type?: string | null;
status?: string | null;
answers: Array<App.DataTransferObjects.QuizQuestionAnswerData> | null;
};
}
