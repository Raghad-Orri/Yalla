import '/backend/api_requests/api_calls.dart';
import '/flutter_flow/flutter_flow_util.dart';
import 's_tpage_auth_widget.dart' show STpageAuthWidget;
import 'package:flutter/material.dart';

class STpageAuthModel extends FlutterFlowModel<STpageAuthWidget> {
  ///  State fields for stateful widgets in this page.

  final unfocusNode = FocusNode();
  // Stores action output result for [Backend Call - API (pickup)] action in Button widget.
  ApiCallResponse? apiResult48u;
  // Stores action output result for [Backend Call - API (messagesG)] action in Button widget.
  ApiCallResponse? apiResult77r;

  @override
  void initState(BuildContext context) {}

  @override
  void dispose() {
    unfocusNode.dispose();
  }
}
