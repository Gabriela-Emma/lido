export default interface LearningModule {
    id: number;
    title:string;
    content?: string;
    link?: string;
    length: number;
    topics_count: number;
    lessons_count: number;
    topics: {id: number, title: string, lessons_count: number, lessons: []}[];
}
