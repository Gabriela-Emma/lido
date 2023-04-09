declare namespace App.DataTransferObjects {
export type LearningLessonData = {
id: number;
title: string;
content: string;
length?: number | null;
link?: string | null;
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
}
