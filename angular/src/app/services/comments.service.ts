import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class CommentsService {

  constructor(private http: HttpClient) { }

  getCommentsList = (slug:string): Observable<any> => {
    const result = this.http.get(`/backend/comments?conf=${slug}&order=desc&limit=6&offset=1`);
    return result;
  }
}
