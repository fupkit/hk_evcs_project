import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';

@Injectable({
  providedIn: 'root'
})

export class DataShareService {
  private sharedLangSource: BehaviorSubject<string> = new BehaviorSubject<string>(null);
  sharedLang = this.sharedLangSource.asObservable();


  constructor() { 
    this.sharedLangSource.next('EN');
  }

  setLang(lang: string) {
    this.sharedLangSource.next(lang);
  }
  getLang() {
    return this.sharedLangSource.getValue();
  }

}