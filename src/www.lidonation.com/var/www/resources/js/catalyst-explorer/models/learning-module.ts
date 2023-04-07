export default interface LearningModule {
    id: number;
    title?:string;
    content: string;
    length: number;
    topics_count: number;
    lessons_count: number;
}
