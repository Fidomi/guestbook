import { ComponentFixture, TestBed } from '@angular/core/testing';
import { UserLoginEditorComponent } from './user-login-editor.component';

describe('UserLoginComponent', () => {
  let component: UserLoginEditorComponent;
  let fixture: ComponentFixture<UserLoginEditorComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ UserLoginEditorComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(UserLoginEditorComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should update the value of the input field', () => {
    const input = fixture.nativeElement.querySelector('input');
    const event = input.dispatchEvent(new Event('input'));

    input.value = 'test@mail.com';
    input.dispatchEvent(event);

    // expect(fixture.componentInstance.userEmailControl.value).toEqual('test@mail.com');
  });
});
