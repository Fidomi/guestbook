import { NgModule } from '@angular/core';
import { HttpClientModule } from '@angular/common/http';
import { BrowserModule } from '@angular/platform-browser';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { FontAwesomeModule } from "@fortawesome/angular-fontawesome";
import { ConferencesComponent } from './components/conferences/conferences.component';
import { ConferenceDetailsComponent } from './components/conference-details/conference-details.component';
import { CommentsListComponent } from './components/comments-list/comments-list.component';


@NgModule({
  declarations: [
    AppComponent,
    ConferencesComponent,
    ConferenceDetailsComponent,
    CommentsListComponent
  ],
  imports: [
    BrowserModule,
    HttpClientModule,
    AppRoutingModule,
    FontAwesomeModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})

// @ts-ignore
export class AppModule { }
