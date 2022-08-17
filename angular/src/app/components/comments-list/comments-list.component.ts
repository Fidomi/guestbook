import { Component, OnInit, Input } from '@angular/core';
import { ConferenceType } from "../../models/conference";
import { CommentType } from "../../models/comment";
import { CommentsService } from "../../services/comments.service";


@Component({
  selector: 'app-comments-list',
  templateUrl: './comments-list.component.html',
  styleUrls: ['./comments-list.component.sass']
})
export class CommentsListComponent implements OnInit {
  @Input() conference!:ConferenceType
  comments: CommentType[] = []
  constructor(private commentsService: CommentsService) { }

  getComments(slug:string) : void {
    this.commentsService.getCommentsList(slug).subscribe(data => this.comments = data.data.adapter.collection);
  }

  ngOnInit(): void {
    this.getComments(this.conference.slug);
  }

}
