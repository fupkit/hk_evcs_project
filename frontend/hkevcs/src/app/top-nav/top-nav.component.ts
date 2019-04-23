import { Component, OnInit } from '@angular/core';
import { DataShareService } from '../data-share.service';

@Component({
  selector: 'app-top-nav',
  templateUrl: './top-nav.component.html',
  styleUrls: ['./top-nav.component.scss']
})
export class TopNavComponent implements OnInit {
  language = 'EN';
  constructor(private share: DataShareService) { }

  ngOnInit() {
  }

  chgLang() {
    if(this.language === 'EN') {
      this.language = 'TC';
    } else {
      this.language = 'EN';
    }
    this.share.setLang(this.language);
    console.log(this.share.getLang());

  }

}
