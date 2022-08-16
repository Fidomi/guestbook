import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { HttpClientModule } from '@angular/common/http';
import { Observable } from 'rxjs';
import { environment } from '../../environments/environment';


@Injectable({
  providedIn: 'root'
})
export class ConferenceService {

  constructor(private http: HttpClient) {
  }

  getConferenceList = (): Observable<any> => {
    const result = this.http.get('/backend/conferences');
    console.log("conferences", result);
    return result;
  }

}