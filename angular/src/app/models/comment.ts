export interface CommentType {
  text: string;
  author: string;
  conference: string;
}

export class Comment {
  text: string;
  author: string;
  conference: string;

  constructor(comment : CommentType) {
    this.text = comment.text;
    this.author = comment.author;
    this.conference = comment.conference;
  }
}
