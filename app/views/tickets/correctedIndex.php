  @elseif(Auth::user()->permission =='Hard')
              @if($ticket['bstatus']!='Finished')
                  <tr>
                    <td>{{$ticket['category']}}</td>
                    <td></td>
                    <td>{{$ticket['created_at']}}</td>
                    <td></td>
                    <td></td>
                    <td class="status" id="status[{{$ticket['_id']}}]">{{$ticket['bstatus']}} </td>

                    <!-- {{isset($ticket['bstatus'])?$ticket['bstatus']:'new'}}
                    @if($ticket['bstatus'] == 'New')
                    <td>
                      <input type="button" class="btn btn-danger Open" id="openAction[{{$ticket['_id']}}]" value="Open"/>
                      <input type="button" class="btn btn-default Close" id="closeAction[{{$ticket['_id']}}]" value="Close" href=""/>
                      <input type="button" class="btn btn-default Refer" id="referAction[{{$ticket['_id']}}]" value="Refer" href=""/>
                    @elseif($ticket['bstatus'] == 'Processing')
                    <td>
                        <input type="button" class="btn btn-default Hold" id="holdAction[{{$ticket['_id']}}]" value="Hold"/>
                        <input type="button" class="btn btn-danger Close" id="closeAction[{{$ticket['_id']}}]" value="Close" href=""/>
                    </td>
                    @elseif($ticket['bstatus'] == 'Holding')
                    <td>
                        <input type="button" class="btn btn-default Unhold" id="unholdAction[{{$ticket['_id']}}]" value="Unhold"/>
                        <input type="button" class="btn btn-danger Close" id="closeAction[{{$ticket['_id']}}]" value="Close" href=""/>
                        <input type="button" class="btn btn-default Refer" id="referAction[{{$ticket['_id']}}]" value="Refer"/>
                    </td>
                    @endif
                    <!-- <td id="status">{{isset($ticket['bstatus'])?$ticket['bstatus']:'new'}}</td> -->
                    <!-- </td> -->
                  </tr>
              @endif
              @endforeach
              @elseif(Auth::user()->permission =='Soft')
                @foreach($tickets as $ticket)
                @if($ticket['bstatus']!='Finished')
                  <tr>
                    <td>{{$ticket['category']}}</td>
                    <td></td>
                    <td>{{$ticket['created_at']}}</td>
                    <td></td>
                    <td></td>
                    <td class="status" id="status[{{$ticket['_id']}}]">{{$ticket['bstatus']}} </td>

                    <!-- {{isset($ticket['bstatus'])?$ticket['bstatus']:'new'}} -->
                    @if($ticket['bstatus'] == 'New')
                    <td>
                      <input type="button" class="btn btn-danger Open" id="openAction[{{$ticket['_id']}}]" value="Open"/>
                      <input type="button" class="btn btn-default Close" id="closeAction[{{$ticket['_id']}}]" value="Close" href=""/>
                      <input type="button" class="btn btn-default Refer" id="referAction[{{$ticket['_id']}}]" value="Refer" href=""/>
                    @elseif($ticket['bstatus'] == 'Processing')
                    <td>
                        <input type="button" class="btn btn-default Hold" id="holdAction[{{$ticket['_id']}}]" value="Hold"/>
                        <input type="button" class="btn btn-danger Close" id="closeAction[{{$ticket['_id']}}]" value="Close" href=""/>
                    </td>
                    @elseif($ticket['bstatus'] == 'Holding')
                    <td>
                        <input type="button" class="btn btn-default Unhold" id="unholdAction[{{$ticket['_id']}}]" value="Unhold"/>
                        <input type="button" class="btn btn-danger Close" id="closeAction[{{$ticket['_id']}}]" value="Close" href=""/>
                        <input type="button" class="btn btn-default Refer" id="referAction[{{$ticket['_id']}}]" value="Refer"/>
                    </td>
                    @endif
                    <!-- <td id="status">{{isset($ticket['bstatus'])?$ticket['bstatus']:'new'}}</td> -->
                    <!-- </td> -->
                  </tr>
                @endif
                @endforeach
              @endif 